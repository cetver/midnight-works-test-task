<?php

namespace Api\V1\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Class CategoryEntity
 *
 * @package Api\V1\Entities
 * @property string $id
 * @property string $public_id
 * @property string $name
 * @property int $_lft;
 * @property int $_rgt;
 * @property int $parent_id;
 * @property \Illuminate\Database\Eloquent\Collection|\Api\V1\Entities\ItemEntity[] $items
 */
class CategoryEntity extends Model
{
    use NodeTrait;
    protected $table = 'categories';
    protected $fillable = ['id', 'public_id', 'parent_id', 'name'];
    protected $hidden = ['id', '_lft', '_rgt', 'parent_id', 'pivot'];
    public $timestamps = false;

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(ItemEntity::class, 'categories_items', 'category_id', 'item_id');
    }
}
