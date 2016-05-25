<?php

namespace directapi\services\bidmodifiers;


use directapi\common\criterias\IdsCriteria;
use directapi\common\criterias\LimitOffset;
use directapi\common\results\ActionResult;
use directapi\common\results\MultiIdsActionResult;
use directapi\services\BaseService;
use directapi\services\bidmodifiers\criterias\BidModifiersSelectionCriteria;
use directapi\services\bidmodifiers\enum\BidModifierFieldEnum;
use directapi\services\bidmodifiers\enum\DemographicsAdjustmentFieldEnum;
use directapi\services\bidmodifiers\enum\MobileAdjustmentFieldEnum;
use directapi\services\bidmodifiers\enum\RetargetingAdjustmentFieldEnum;
use directapi\services\bidmodifiers\models\BidModifierAddItem;
use directapi\services\bidmodifiers\models\BidModifierGetItem;
use directapi\services\bidmodifiers\models\BidModifierSetItem;
use directapi\services\bidmodifiers\models\BidModifierToggleItem;
use directapi\services\bidmodifiers\results\ToggleResult;

class BidModifiersService extends BaseService
{
    const SERVICE = 'BidModifiers';
    /**
     * @param BidModifierAddItem[] $BidModifiers
     *
     * @return MultiIdsActionResult[]
     */
    public function add(array $BidModifiers)
    {
        $params = [
            self::SERVICE => $BidModifiers
        ];
        return parent::doAdd($params);
    }

    /**
     * @inheritdoc
     */
    public function delete(IdsCriteria $SelectionCriteria)
    {
        return parent::delete($SelectionCriteria);
    }

    /**
     * @param BidModifiersSelectionCriteria     $SelectionCriteria
     * @param BidModifierFieldEnum              $FieldNames
     * @param MobileAdjustmentFieldEnum[]       $MobileAdjustmentFieldNames
     * @param DemographicsAdjustmentFieldEnum[] $DemographicsAdjustmentFieldNames
     * @param RetargetingAdjustmentFieldEnum[]  $RetargetingAdjustmentFieldNames
     * @param LimitOffset|null                  $Page
     *
     * @return BidModifierGetItem[]
     */
    public function get(
        BidModifiersSelectionCriteria $SelectionCriteria,
        $FieldNames,
        array $MobileAdjustmentFieldNames = [],
        array $DemographicsAdjustmentFieldNames = [],
        array $RetargetingAdjustmentFieldNames = [],
        LimitOffset $Page = null
    ) {
        $params = [
            'SelectionCriteria' => $SelectionCriteria,
            'FieldNames'        => $FieldNames,
        ];
        if ($MobileAdjustmentFieldNames) {
            $params['MobileAdjustmentFieldNames'] = $MobileAdjustmentFieldNames;
        }
        if ($DemographicsAdjustmentFieldNames) {
            $params['DemographicsAdjustmentFieldNames'] = $DemographicsAdjustmentFieldNames;
        }
        if ($RetargetingAdjustmentFieldNames) {
            $params['RetargetingAdjustmentFieldNames'] = $RetargetingAdjustmentFieldNames;
        }
        if ($Page) {
            $params['Page'] = $Page;
        }
        return parent::doGet($params, self::SERVICE, false);
    }

    /**
     * @param BidModifierSetItem[] $BidModifiers
     *
     * @return ActionResult[]
     */
    public function set(array $BidModifiers)
    {
        $params = [
            self::SERVICE => $BidModifiers
        ];
        $result = $this->call('set', $params);
        return $result->SetResults;
        //return $this->mapArray($result->SetResults, ActionResult::class);
    }

    /**
     * @param BidModifierToggleItem[] $BidModifierToggleItems
     *
     * @return ToggleResult[]
     */
    public function toggle(array $BidModifierToggleItems)
    {
        $params = [
            'BidModifierToggleItems' => $BidModifierToggleItems
        ];
        $result = $this->call('toggle', $params);
        return $result->SetResults;
        //return $this->mapArray($result->SetResults, ToggleResult::class);
    }

    protected function getName()
    {
        return strtolower(self::SERVICE);
    }
}