<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\ArchiveVideos
 *
 * @property int $id
 * @property string $title
 * @property string $video_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ArchiveVideos onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos whereVideoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArchiveVideos withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ArchiveVideos withoutTrashed()
 * @mixin \Eloquent
 */
	class ArchiveVideos extends \Eloquent {}
}

namespace App{
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
 */
	class AuditLogs extends \Eloquent {}
}

namespace App{
/**
 * App\Booth
 *
 * @property string $id
 * @property string $room_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $admins
 * @property-read int|null $admins_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Image[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Resource[] $resources
 * @property-read int|null $resources_count
 * @property-read \App\Room $room
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Video[] $videos
 * @property-read int|null $videos_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Booth onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booth withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Booth withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $boothurl
 * @method static \Illuminate\Database\Eloquent\Builder|Booth whereBoothurl($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BoothInterest[] $interests
 * @property-read int|null $interests_count
 * @property int $status 0 = Not Published / 1 = Published
 * @property string|null $calendly_link
 * @method static \Illuminate\Database\Eloquent\Builder|Booth onlyPublished()
 * @method static \Illuminate\Database\Eloquent\Builder|Booth whereCalendlyLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booth whereStatus($value)
 */
	class Booth extends \Eloquent {}
}

namespace App{
/**
 * App\BoothAdmin
 *
 * @property string $id
 * @property string $user_id
 * @property string $booth_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\BoothAdmin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin whereBoothId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BoothAdmin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\BoothAdmin withoutTrashed()
 * @mixin \Eloquent
 */
	class BoothAdmin extends \Eloquent {}
}

namespace App{
/**
 * App\BoothInterest
 *
 * @property int $id
 * @property string $booth_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Booth $booth
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|BoothInterest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoothInterest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoothInterest query()
 * @method static \Illuminate\Database\Eloquent\Builder|BoothInterest whereBoothId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoothInterest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoothInterest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoothInterest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoothInterest whereUserId($value)
 * @mixin \Eloquent
 */
	class BoothInterest extends \Eloquent {}
}

namespace App{
/**
 * App\Contact
 *
 * @property int $id
 * @property string $user_id
 * @property string $contact_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUserId($value)
 * @mixin \Eloquent
 */
	class Contact extends \Eloquent {}
}

namespace App{
/**
 * App\Content
 *
 * @property string $id
 * @property string $name
 * @property string|null $value
 * @property string $type
 * @property string|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $section
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Content onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Content withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Content withoutTrashed()
 * @mixin \Eloquent
 */
	class Content extends \Eloquent {}
}

namespace App{
/**
 * App\Device
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @mixin \Eloquent
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_id
 * @property string $device_id
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUserId($value)
 */
	class Device extends \Eloquent {}
}

namespace App{
/**
 * App\EventSession
 *
 * @property string $id
 * @property string $room
 * @property string|null $name
 * @property string $type
 * @property string|null $vimeo_url
 * @property string|null $zoom_webinar_id
 * @property string|null $zoom_password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $start_time
 * @property \Illuminate\Support\Carbon|null $end_time
 * @property string|null $region
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SessionModerator[] $moderators
 * @property-read int|null $moderators_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SessionPoll[] $polls
 * @property-read int|null $polls_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SessionSpeaker[] $speakers
 * @property-read int|null $speakers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\EventSession onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereRoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereVimeoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereZoomPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereZoomWebinarId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EventSession withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\EventSession withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $past_video
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EventSubscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|EventSession wherePastVideo($value)
 */
	class EventSession extends \Eloquent {}
}

namespace App{
/**
 * App\EventSubscription
 *
 * @property int $id
 * @property string $session_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\EventSession $event
 * @property-read \App\User $user
 * @property-read \App\User $user_min
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription whereUserId($value)
 */
	class EventSubscription extends \Eloquent {}
}

namespace App{
/**
 * App\FAQ
 *
 * @property string $id
 * @property string $question
 * @property string $answer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\FAQ onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FAQ withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\FAQ withoutTrashed()
 * @mixin \Eloquent
 */
	class FAQ extends \Eloquent {}
}

namespace App{
/**
 * App\Image
 *
 * @property string $id
 * @property string $owner
 * @property string $title
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $link
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Image onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Image withoutTrashed()
 * @mixin \Eloquent
 */
	class Image extends \Eloquent {}
}

namespace App{
/**
 * App\LoginLog
 *
 * @property string $id
 * @property string $ip
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog query()
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog whereUserId($value)
 */
	class LoginLog extends \Eloquent {}
}

namespace App{
/**
 * App\Notification
 *
 * @property int $id
 * @property string $title
 * @property string $user_id
 * @property string|null $details
 * @property string $type
 * @property string $action_type
 * @property string $action_id
 * @property string|null $action_status
 * @property string|null $meta
 * @property int $sent
 * @property int $read
 * @property int $clicked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereActionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereActionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereClicked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUserId($value)
 * @mixin \Eloquent
 */
	class Notification extends \Eloquent {}
}

namespace App{
/**
 * App\Option
 *
 * @property string $id
 * @property string $question_id
 * @property string $text
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VoteOption[] $vote_options
 * @property-read int|null $vote_options_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Option onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Option withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Option withoutTrashed()
 * @mixin \Eloquent
 */
	class Option extends \Eloquent {}
}

namespace App{
/**
 * App\Points
 *
 * @property string $id
 * @property string $for
 * @property string $to
 * @property int $points
 * @property string $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Points onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Points withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Points withoutTrashed()
 * @mixin \Eloquent
 * @property string $points_for
 * @property string $points_to
 * @method static \Illuminate\Database\Eloquent\Builder|Points wherePointsFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Points wherePointsTo($value)
 */
	class Points extends \Eloquent {}
}

namespace App{
/**
 * App\Poll
 *
 * @property string $id
 * @property string $name
 * @property int $status
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $questions
 * @property-read int|null $questions_count
 * @property-read \App\SessionPoll|null $session_poll
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vote[] $votes
 * @property-read int|null $votes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Poll onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Poll withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Poll withoutTrashed()
 * @mixin \Eloquent
 */
	class Poll extends \Eloquent {}
}

namespace App{
/**
 * App\Prize
 *
 * @property string $id
 * @property int $criteria_low
 * @property int $criteria_high
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Image[] $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Prize onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereCriteriaHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereCriteriaLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Prize withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Prize withoutTrashed()
 * @mixin \Eloquent
 */
	class Prize extends \Eloquent {}
}

namespace App{
/**
 * App\ProvisionalGroup
 *
 * @property string $id
 * @property string|null $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Resource[] $resource
 * @property-read int|null $resource_count
 * @property-read \App\Video|null $video
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ProvisionalGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProvisionalGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ProvisionalGroup withoutTrashed()
 * @mixin \Eloquent
 */
	class ProvisionalGroup extends \Eloquent {}
}

namespace App{
/**
 * App\Question
 *
 * @property string $id
 * @property string $text
 * @property string $poll_id
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Option[] $options
 * @property-read int|null $options_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VoteOption[] $vote_options
 * @property-read int|null $vote_options_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Question onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question wherePollId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Question withoutTrashed()
 * @mixin \Eloquent
 */
	class Question extends \Eloquent {}
}

namespace App{
/**
 * App\Report
 *
 * @property string $id
 * @property string|null $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $region
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Resource[] $resources
 * @property-read int|null $resources_count
 * @property-read \App\Video|null $video
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Report onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Report withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Report withoutTrashed()
 * @mixin \Eloquent
 */
	class Report extends \Eloquent {}
}

namespace App{
/**
 * App\Resource
 *
 * @property string $id
 * @property string $title
 * @property string $url
 * @property string $booth_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Booth $booth
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Swagbag[] $swagbag
 * @property-read int|null $swagbag_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Resource onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereBoothId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Resource withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Resource withoutTrashed()
 * @mixin \Eloquent
 */
	class Resource extends \Eloquent {}
}

namespace App{
/**
 * App\Room
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $position
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booth[] $booths
 * @property-read int|null $booths_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Room onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Room withoutTrashed()
 * @mixin \Eloquent
 */
	class Room extends \Eloquent {}
}

namespace App{
/**
 * App\SessionModerator
 *
 * @property string $id
 * @property string|null $user_id
 * @property string|null $session_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\EventSession|null $session
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\SessionModerator onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SessionModerator withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SessionModerator withoutTrashed()
 * @mixin \Eloquent
 */
	class SessionModerator extends \Eloquent {}
}

namespace App{
/**
 * App\SessionPoll
 *
 * @property string $id
 * @property string|null $poll_id
 * @property string|null $session_id
 * @property string|null $creator
 * @property string|null $start_time
 * @property string|null $end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $timer
 * @property string|null $status
 * @property-read \App\Poll|null $poll
 * @property-read \App\EventSession|null $session
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\SessionPoll onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll wherePollId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereTimer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SessionPoll withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SessionPoll withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereCreator($value)
 */
	class SessionPoll extends \Eloquent {}
}

namespace App{
/**
 * App\SessionSpeaker
 *
 * @property string $id
 * @property string|null $session_id
 * @property string|null $speaker_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\EventSession|null $session
 * @property-read \App\Speaker|null $speaker
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\SessionSpeaker onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker whereSpeakerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SessionSpeaker withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SessionSpeaker withoutTrashed()
 * @mixin \Eloquent
 */
	class SessionSpeaker extends \Eloquent {}
}

namespace App{
/**
 * App\Speaker
 *
 * @property string $id
 * @property string|null $name
 * @property string|null $photo
 * @property string|null $bio
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SessionSpeaker[] $sessions
 * @property-read int|null $sessions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Speaker onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Speaker withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Speaker withoutTrashed()
 * @mixin \Eloquent
 */
	class Speaker extends \Eloquent {}
}

namespace App{
/**
 * App\Swagbag
 *
 * @property string $id
 * @property string $user_id
 * @property string $resources_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\ProvisionalGroup $provision
 * @property-read \App\Report $report
 * @property-read \App\Resource $resource
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Swagbag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag whereResourcesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Swagbag withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Swagbag withoutTrashed()
 * @mixin \Eloquent
 */
	class Swagbag extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property string $id
 * @property string $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string $type
 * @property \Illuminate\Database\Eloquent\Collection|\App\Points[] $points
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $profileImage
 * @property bool $isCometChatAccountExist
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string|null $member_id
 * @property string|null $region_name
 * @property string|null $salutation
 * @property string|null $phone_number
 * @property string|null $street
 * @property string|null $street_2
 * @property string|null $street_3
 * @property string|null $state
 * @property string|null $postal
 * @property string|null $city
 * @property string|null $role
 * @property string|null $tshirt_size
 * @property int $online_status
 * @property string|null $current_page
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booth[] $booths
 * @property-read int|null $booths_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SessionModerator[] $event_session
 * @property-read int|null $event_session_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read int|null $points_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Swagbag[] $swagbag
 * @property-read int|null $swagbag_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vote[] $votes
 * @property-read int|null $votes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCurrentPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsCometChatAccountExist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereOnlineStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRegionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSalutation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStreet2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStreet3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTshirtSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\LoginLog[] $login_logs
 * @property-read int|null $login_logs_count
 * @property string|null $phone
 * @property string|null $job_title
 * @property string|null $company_name
 * @property string|null $country
 * @property string|null $industry
 * @property string|null $bio
 * @property string|null $facebook_link
 * @property string|null $twitter_link
 * @property string|null $linkedin_link
 * @property string|null $website_link
 * @property string|null $company_website_link
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contact[] $contact_users
 * @property-read int|null $contact_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserTag[] $looking_for_tags
 * @property-read int|null $looking_for_tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserConnection[] $requests
 * @property-read int|null $requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserConnection[] $requests_sent
 * @property-read int|null $requests_sent_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserTagLinks[] $tagLinks
 * @property-read int|null $tag_links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserLookingTagLinks[] $tagLookingLinks
 * @property-read int|null $tag_looking_links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserTag[] $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Notification[] $unread_notifications
 * @property-read int|null $unread_notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Notification[] $unsent_notifications
 * @property-read int|null $unsent_notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompanyWebsiteLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFacebookLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLinkedinLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwitterLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWebsiteLink($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Device[] $devices
 * @property-read int|null $devices_count
 * @property string|null $company_size
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserInterests[] $interests
 * @property-read int|null $interests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EventSubscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompanySize($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App{
/**
 * App\UserConnection
 *
 * @property int $id
 * @property string $user_id
 * @property string $connection_id
 * @property int $status [-1 = Declined, 0 = Pending, 1 = Accepted]
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $receiver
 * @property-read \App\User $sender
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection whereConnectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection whereUserId($value)
 * @mixin \Eloquent
 */
	class UserConnection extends \Eloquent {}
}

namespace App{
/**
 * App\UserInterests
 *
 * @property int $id
 * @property string $interest
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests whereUserId($value)
 */
	class UserInterests extends \Eloquent {}
}

namespace App{
/**
 * App\UserLookingTagLinks
 *
 * @property int $id
 * @property int $tag_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\UserTag $tag
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks whereUserId($value)
 * @mixin \Eloquent
 */
	class UserLookingTagLinks extends \Eloquent {}
}

namespace App{
/**
 * App\UserTag
 *
 * @property int $id
 * @property string $tag
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $user_id
 * @property-read int|null $user_id_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserTag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|UserTag withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserTag withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $looking_users
 * @property-read int|null $looking_users_count
 */
	class UserTag extends \Eloquent {}
}

namespace App{
/**
 * App\UserTagLinks
 *
 * @property int $id
 * @property int $tag_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\UserTag $tag
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks whereUserId($value)
 * @mixin \Eloquent
 */
	class UserTagLinks extends \Eloquent {}
}

namespace App{
/**
 * App\Video
 *
 * @property string $id
 * @property string $owner
 * @property string|null $title
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $thumbnail
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Video onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Video withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Video withoutTrashed()
 * @mixin \Eloquent
 */
	class Video extends \Eloquent {}
}

namespace App{
/**
 * App\Vote
 *
 * @property string $id
 * @property string $poll_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status
 * @property-read \App\Poll $poll
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VoteOption[] $vote_options
 * @property-read int|null $vote_options_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Vote onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote wherePollId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Vote withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Vote withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $user
 */
	class Vote extends \Eloquent {}
}

namespace App{
/**
 * App\VoteOption
 *
 * @property string $id
 * @property string $vote_id
 * @property string $question_id
 * @property string $option_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Option $option
 * @property-read \App\Vote $vote
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\VoteOption onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereVoteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VoteOption withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\VoteOption withoutTrashed()
 * @mixin \Eloquent
 */
	class VoteOption extends \Eloquent {}
}

