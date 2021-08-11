<?php
namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;
use Illuminate\Support\Str;

class WaitTimePresenter extends BasePresenter
{
    public function display()
    {
        return $this->entity->duration . ' ' . Str::plural($this->entity->units, $this->entity->duration);
    }
}
