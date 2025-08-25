<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

abstract class BaseFlexibleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Hint from outside (optional) for channel preference
     * Example: new OrderCompleted($data, preferred: 'sms')
     */
    public function __construct(protected ?string $preferred = null)
    {
        $this->afterCommit();
    }

    /**
     * channel list support
     * @return array ['sms','database','push']
     */
    abstract protected function supportedChannels(): array;

    /**
     * Event key to map to user preferences
     * Example: 'orders.completed'
     */
    abstract protected function eventKey(): string;

    /**
     * Determine channels at the time of sending. The logic is hidden here.
     */
    public function via($notifiable): array
    {
        $supported = $this->supportedChannels();

        if ($this->preferred && in_array($this->preferred, $supported)) {
            return [$this->preferred === 'push' ? 'broadcast' : $this->preferred];
        }

        $pref = $notifiable->notificationPreference;
        if ($pref) {
            $eventChannels = Arr::get($pref->channels_per_event, $this->eventKey());
            if (is_string($eventChannels) && in_array($eventChannels, $supported)) {
                return [$eventChannels === 'push' ? 'broadcast' : $eventChannels];
            }
            if (is_array($eventChannels)) {
                $channels = array_values(array_intersect($eventChannels, $supported));
                if (!empty($channels)) {
                    return [($channels[0] === 'push') ? 'broadcast' : $channels[0]];
                }
            }
            if ($pref->default_channel && in_array($pref->default_channel, $supported)) {
                return [$pref->default_channel === 'push' ? 'broadcast' : $pref->default_channel];
            }
        }


        if (in_array('sms', $supported) && method_exists(
                $notifiable,
                'hasActivePhoneNumber'
            ) && $notifiable->hasActivePhoneNumber()) {
            return ['sms'];
        }
        if (in_array('push', $supported)) {
            return ['broadcast'];
        }
        return in_array('database', $supported) ? ['database'] : [$supported[0]];
    }

    /**
     * User language to translate messages
     */
    protected function localeFor($notifiable): string
    {
        return method_exists($notifiable, 'preferredLocale')
            ? $notifiable->preferredLocale()
            : App::getLocale();
    }
}
