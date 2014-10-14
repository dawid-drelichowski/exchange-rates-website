<?php
namespace Kantor\Service;


class ExchangeRateChangeDetector
{
    /**
     * @var array
     */
    private $added = array();

    /**
     * @var array
     */
    private $updated = array();

    /**
     * @var array
     */
    private $removed = array();

    /**
     * @param array $before
     * @param array $after
     */
    public function detect(array $before, array $after)
    {
        $this->removed = $this->added = $this->updated = array();
        foreach ($before as $type => $rates) {
            $this->removed = array_merge($this->removed, array_diff_key($rates, $after[$type]));

            $this->added = array_merge($this->added, array_diff_key($after[$type], $rates));

            $this->updated = array_merge($this->updated, array_udiff_assoc(
                array_diff_key($after[$type], $this->added),
                $rates,
                function ($first, $second) {
                    if ($first == $second) {
                        return 0;
                    }
                    return 1;
                }
            ));
        }
    }

    /**
     * @return array
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * @return array
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return array
     */
    public function getRemoved()
    {
        return $this->removed;
    }
} 