<?php

namespace App\Services;

use DateTime;
use App\Entity\Category;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints as Assert;

class RechercheChambre{
    /**
     * Undocumented variable
     *
     * @var DateTime
     */
    private $date_depart;
    /**
     * Undocumented variable
     *
     * @var DateTime
     */
    private $date_arrive;
    
    /**
     * Undocumented variable
     *
     * @var Category
     */
        private $category;

        public function getCategory(): ?Category
        {
            return $this->category;
        }
    
        public function setCategory(?Category $category): self
        {
            $this->category = $category;
    
            return $this;
        }
        /**
         * Undocumented function
         *
         * @return DateTime
         */
    public function getDateArrive()
    {
        return $this->date_arrive;
    }
    /**
     * Undocumented function
     *
     * @param DateTime $date_arrive
     * @return self
     */
    public function setDateArrive(DateTime $date_arrive)
    {
        $this->date_arrive = $date_arrive;

        return $this;
    }
    /**
     * Undocumented function
     *
     * @return DateTime
     */
    public function getDateDepart()
    {
        return $this->date_depart;
    }
    /**
     * Undocumented function
     *
     * @param DateTime $date_depart
     * @return self
     */
    public function setDateDepart(DateTime $date_depart)
    {
        $this->date_depart = $date_depart;

        return $this;
    }
}
