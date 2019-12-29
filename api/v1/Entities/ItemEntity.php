<?php

namespace Api\V1\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemEntity
 *
 * @package Api\V1\Entities
 *
 * @property string $id
 * @property string $public_id
 * @property string $name
 */
class ItemEntity extends Model
{
    protected $table = 'items';
    protected $fillable = ['id', 'public_id', 'name'];
    protected $hidden = ['id', 'pivot'];
    public $timestamps = false;

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
