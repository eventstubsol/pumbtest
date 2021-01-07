<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AuditLogs
 *
 * @property int $id
 * @property string $type
 * @property string $user_id
 * @property string $label
 * @property string $details
 * @property string $ip_address
 * @property string $user_agent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLogs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLogs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLogs query()
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLogs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLogs whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLogs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLogs whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLogs whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLogs whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLogs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLogs whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLogs whereUserId($value)
 * @mixin \Eloquent
 */
class AuditLogs extends Model
{
    //
}
