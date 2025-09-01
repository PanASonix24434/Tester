<?php

use App\Models\ProfileUser;

function getOwnedVessels($owner_id) {
    $owner = ProfileUser::find($owner_id) ?? new ProfileUser;
    return $owner->ownedVessels()->get();
}
