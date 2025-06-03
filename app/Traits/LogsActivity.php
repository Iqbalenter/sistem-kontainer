<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function (Model $model) {
            $model->logActivity('created');
        });

        static::updated(function (Model $model) {
            $model->logActivity('updated');
        });

        static::deleted(function (Model $model) {
            $model->logActivity('deleted');
        });
    }

    protected function logActivity(string $event)
    {
        ActivityLog::create([
            'log_name' => class_basename($this),
            'description' => $this->getActivityDescription($event),
            'subject_type' => get_class($this),
            'subject_id' => $this->id,
            'causer_type' => Auth::user() ? get_class(Auth::user()) : null,
            'causer_id' => Auth::id(),
            'properties' => $this->getActivityProperties(),
            'event' => $event,
        ]);
    }

    protected function getActivityDescription(string $event): string
    {
        return ucfirst($event) . ' ' . strtolower(class_basename($this));
    }

    protected function getActivityProperties(): array
    {
        return [
            'attributes' => $this->getAttributes(),
            'old' => $this->getOriginal(),
        ];
    }
} 