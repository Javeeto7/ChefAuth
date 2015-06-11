<?php

namespace Reivaj86\ChefAuth\Contracts;

interface CategoryContract
{
    /**
     * Category belongs to many ingredients.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients();

    /**
     * Category belongs to many recipes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recipes();
}
