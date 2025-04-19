<?php

use App\Models\TokenCreator;

Schedule::call([TokenCreator::class, "deleteAllOld"])->at('10:00');
