<?php

namespace Stc\Bundle\ContractBundle\Model\VariableModel;

class SbwtVariableModel extends AbstractVariableModel
{
    public function __construct()
    {
        $this->vars = [
            'band_name' => '',
            'tribute_to' => '',
            'performance_date' => '',
            'venue_name' => '',
            'venue_contact_name' => '',
            'venue_billing_address' => '',
            'venue_phone' => '',
            'venue_email' => '',
            'additional_info' => '',
            'band_contact_name' => '',
            'band_phone' => '',
            'band_email' => '',
            'backline ' => '',
            'load_in_at' => '',
            'sound_check_at' => '',
            'performance_starts_at' => '',
            'performance_ends_at' => '',
            'venue_capacity' => '',
            'ticket_price' => '',
            'notes_other_bands' => '',
            'pa' => '',
            'venue_age_limit' => '',
            'performance_fee' => '',
            'performance_deposit' => '',
            'total_deposit_due' => '',
            'travel_budget' => '',
            'number_meals_provided' => '',
            'number_drinks_provided' => '',
            'number_adults_accommodated' => '',
            'number_flights' => '',
            'flight_from_city_state' => '',
            'flight_to_city_state' => '',
            'travel_buyout' => '',
            'venue_emergency_phone' => '',
            'venue_fax' => '',
            'venue_website' => '',
            'number_clean_towels' => '',
            'number_meals_buyout' => '',
            'band_billed_by' => '',
            'date_signed' => ''
        ];
    }

    public function setVars($vars = array())
    {

    }

    public function getVars()
    {
        return $this->vars;
    }

    public function set($var, $value)
    {
        if (in_array($var, $this->vars)) {
            $this->vars[$var] = $value;
        }
    }
}