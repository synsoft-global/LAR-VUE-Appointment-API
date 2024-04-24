<?php

namespace App\Observers;

use App\Models\SubCategory;

class SubCategoryObserver
{
    /**
     * Handle the SubCategory "created" event.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return void
     */
    public function created(SubCategory $subcategory)
    {
        //
    }

    /**
     * Handle the SubCategory "creating" event.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return void
     */
    public function creating(SubCategory $subcategory)
    {
        $subcategory->slug = strtolower(\Str::slug($subcategory->title));

    }

    /**
     * Handle the SubCategory "updated" event.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return void
     */
    public function updated(SubCategory $subcategory)
    {
        //
    }

    /**
     * Handle the SubCategory "updated" event.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return void
     */
    public function updating(SubCategory $subcategory)
    {
        $subcategory->slug = strtolower(\Str::slug($subcategory->title));
    }

    /**
     * Handle the SubCategory "deleted" event.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return void
     */
    public function deleted(SubCategory $subcategory)
    {
        //
    }

    /**
     * Handle the SubCategory "restored" event.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return void
     */
    public function restored(SubCategory $subcategory)
    {
        //
    }

    /**
     * Handle the SubCategory "force deleted" event.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return void
     */
    public function forceDeleted(SubCategory $subcategory)
    {
        //
    }
}
