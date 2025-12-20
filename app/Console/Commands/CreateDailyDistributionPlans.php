<?php

namespace App\Console\Commands;

use App\Models\ProductionSchedule;
use App\Models\Sppg;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateDailyDistributionPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distribution:generate-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-generate daily distribution plan records for all active SPPGs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $this->info("Generating distribution plans for: {$today->toDateString()}");

        // Get all active SPPGs
        $sppgs = Sppg::whereHas('schools')->get();
        
        if ($sppgs->isEmpty()) {
            $this->warn('No active SPPGs found with schools.');
            return Command::SUCCESS;
        }

        $created = 0;
        $skipped = 0;

        foreach ($sppgs as $sppg) {
            // Check if record already exists for today
            $exists = ProductionSchedule::where('sppg_id', $sppg->id)
                ->whereDate('tanggal', $today)
                ->exists();

            if ($exists) {
                $this->line("⏭️  Skipped: {$sppg->nama_sppg} (already exists)");
                $skipped++;
                continue;
            }

            // Create new distribution plan
            ProductionSchedule::create([
                'sppg_id' => $sppg->id,
                'tanggal' => $today,
                'menu_hari_ini' => null, // To be filled by admin
                'status' => 'Direncanakan',
            ]);

            $this->info("✅ Created: {$sppg->nama_sppg}");
            $created++;
        }

        $this->newLine();
        $this->info("Summary:");
        $this->info("  Created: {$created}");
        $this->info("  Skipped: {$skipped}");
        $this->info("  Total SPPGs: " . $sppgs->count());

        return Command::SUCCESS;
    }
}
