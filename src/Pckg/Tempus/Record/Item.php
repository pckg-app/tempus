<?php namespace Pckg\Tempus\Record;

use Pckg\Database\Record;
use Pckg\Tempus\Entity\Items;

class Item extends Record
{

    protected $entity = Items::class;

    public function getProgramGroup() {
        /**
         * @T00D00 - This needs to be added as filter on frontend!
         */
        if ($this->idle > 2 * 60 * 1000) {
            return 'IDLE';
        } else {
            if (strpos($this->program, 'chrome') || strpos($this->program, 'chromium')) {
                return 'Browser';
            } elseif (strpos($this->program, 'terminal')) {
                return 'Terminal';
            } elseif (strpos($this->program, 'skype')) {
                return 'Skype';
            } elseif (strpos($this->program, 'geary')) {
                return 'Email';
            } elseif (strpos($this->program, 'jetbrains')) {
                return 'Developing';
            } elseif (strpos($this->program, 'libre')) {
                return 'Office';
            } elseif (strpos($this->program, 'TeamViewer')) {
                return 'Remote';
            } elseif (
                strpos($this->program, 'gnome') ||
                strpos($this->program, 'system') ||
                strpos($this->program, 'navigator') ||
                strpos($this->program, 'Navigator') ||
                strpos($this->program, 'nautilus') ||
                strpos($this->program, 'desktop') ||
                strpos($this->program, 'unity') ||
                strpos($this->program, 'gcr-viewer') ||
                strpos($this->program, 'file-roller')
            ) {
                return 'System';
            } elseif (!$this->program) {
                return '-- not set --';
            }
        }

        return $this->program;
    }

    public function getReadableDuration() {
        return \Pckg\Tempus\Controller\get_date_diff(
                   0,
                   $this->duration_sum
               ) . ' (' . \Pckg\Tempus\Controller\get_date_diff(0, $this->duration_calc) . ')';
    }

}