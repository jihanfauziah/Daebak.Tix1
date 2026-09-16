<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class CheckEventExpiry extends Command
{
    protected $signature = 'events:check-expiry';
    protected $description = 'Automatically deactivate expired seller events';

    public function handle()
    {
        $expiredEvents = Event::where('status', 'active')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($expiredEvents as $event) {
            $event->update(['status' => 'expired']);
            $this->info("Deactivated expired event ID #{$event->id}: {$event->title}");
        }

        $this->info("Checked " . count($expiredEvents) . " expired events.");
        return Command::SUCCESS;
    }
}
