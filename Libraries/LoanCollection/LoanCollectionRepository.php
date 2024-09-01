<?php

namespace App\Libraries\LoanCollection;

use App\Models\Loan;
use Illuminate\Support\Facades\Cache;
use App\Models\CollectionType;
use App\Models\Collection;

class LoanCollectionRepository
{
    /**
     * Get EMI Table
     *
     * @return \Illuminate\Support\Collection
     */
    public function getEmiTable(Loan $loan)
    {
        $collectionType = $this->getCollectionTypeById($loan->collection_type_id);

        $manager = LoanCollectionManager::driver($collectionType->slug);

        return $manager->getEmiTable($loan);
    }

    /**
     * Initialize EMI Table for Given Loan
     *
     * @param Loan $loan
     * @return Loan|Boolean
     */
    public function initEmiCollections(Loan $loan)
    {
        $collections = $this->getEmiTable($loan);

        if ($loan->collections()->count() > 0) {
            return false;
        }

        $loan->collections()->saveMany($collections);

        return $loan;
    }

    /**
     * Get all collection types
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollectionTypes()
    {
        return Cache::rememberForever('collection_types', function () {
            return CollectionType::query()->select(['id', 'slug', 'name'])->all()->keyBy('id');
        });
    }

    /**
     * Get a collection by id
     *
     * @param integer $id
     * @return Collection
     */
    public function getCollectionTypeById($id)
    {
        return $this->getCollectionTypes()->get($id);
    }
}
