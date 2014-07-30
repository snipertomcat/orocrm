<?php

namespace Stc\Bundle\MapBundle\Model\Generator;

use Stc\Bundle\MapBundle\Entity\Map;
use Stc\Bundle\MapBundle\Model\VariableModel\AbstractVariableModel;

class MapGenerator
{
    /**
     * @var Map
     */
    protected $map;

    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * @var AbstractVariableModel
     */
    protected $variableModel;

    /**
     * @var $page_data
     */
    public $page_data;

    protected $template;

    public function __construct(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /** @noinspection PhpExpressionResultUnusedInspection */
    public function generate()
    {
        if ($this->map !== null) {
            $page_data = $this->variableModel->getVars();

            $performance = $this->map->getPerformance();
            $type = $this->map->getMapType();
            if ($type == 'sbwt' || $type == 'sbnt') {
                $multiBand = false;
            } else {
                $multiBand = true;
            }
            if ($type == 'mbwt' || $type == 'sbwt') {
                $travel = true;
            } else {
                $travel = false;
            }

            $bands = $performance->getBands();
            //print_r($bands->current());exit;

            if ($multiBand) {
                //select correct bands - display sub-form?

            } else {
                //just grab the 1st one:
                $band = $bands->first();

                $page_data['band_name'] = $band->getName();
                $page_data['tribute_to'] = $band->getTributeTo();
                $page_data['band_contact_name'] = ' ';
                $page_data['band_phone'] = $band->getPhoneOffice();
                $page_data['band_email'] = ' ';
            }
            $venue = $performance->getVenue();

            $page_data['venue_name'] = $venue->getName();
            //$page_data['venue_contact_name'] = $venue->getContacts();
            $page_data['venue_contact_name'] = ' ';
            $page_data['venue_billing_address'] = $venue->getBillingAddressStreet() . ' ' .
                                                  $venue->getBillingAddressCity() . ',' .
                                                  $venue->getBillingAddressState() . ' ' .
                                                  $venue->getBillingAddressPostalcode();
            $page_data['venue_capacity'] = $venue->getCapacity();
            $page_data['venue_phone'] = $venue->getPhoneOffice();
            $page_data['venue_email'] = ' ';
            $page_data['venue_website'] = $venue->getWebsite();
            $page_data['venue_fax'] = $venue->getPhoneFax();
            $page_data['venue_emergency_phone'] = ' ';
            $page_data['additional_info'] = ' ';
            $page_data['backline'] = ' ';
            $page_data['load_in_at'] = $performance->getLoadInAt();
            $page_data['sound_check_at'] = $performance->getSoundCheckAt();
            $page_data['performance_starts_at'] = $performance->getPerformanceDate();
            $page_data['performance_ends_at'] = $performance->getPerformanceEndAt();
            $page_data['ticket_price'] = $performance->getAmount();
            $page_data['notes_other_bands'] = ' ';
            $page_data['pa'] = ' ';
            $page_data['venue_age_limit'] = $venue->getAgeLimit();
            $page_data['performance_fee'] = $performance->getPerformanceFee();
            $page_data['performance_deposit'] = ' ';
            $page_data['total_deposit_due'] = ' ';
            $page_data['travel_budget'] = $performance->getBudget();
            $page_data['number_meals_provided'] = ' ';
            $page_data['number_drinks_provided'] = ' ';
            $page_data['number_adults_accomodated'] = ' ';
            $page_data['number_flights'] = ' ';
            $page_data['flight_from_city_state'] = ' ';
            $page_data['flight_to_city_state'] = ' ';
            $page_data['travel_buyout'] = ' ';
            $page_data['number_clean_towels'] = ' ';
            $page_data['number_meals_buyout'] = ' ';
            $page_data['band_billing_by'] = ' ';
            $page_data['date_signed'] = $this->map->getSignedAt();

            $this->page_data = $page_data;

            return $page_data;
        }
    }

    public function convertDateObjectsToString()
    {
        foreach ($this->page_data as $key=>$val) {
            if ($val instanceof \DateTime) {
                $this->page_data[$key] = $val->format('Y-m-d H:i:s');
            }
        }
    }

    public function setVariableModel(AbstractVariableModel $variableModel)
    {
        $this->variableModel = $variableModel;
    }

    public function setMap(Map $map)
    {
        $this->map = $map;
        $this->setLocalVariables();
    }

    public function setLocalVariables()
    {
        $this->template = 'StcMapBundle:MapTemplate:' . $this->map->getMapType() . '.html.twig';
        $varModel = 'Stc\Bundle\MapBundle\Model\VariableModel\\'.ucfirst(strtolower($this->map->getMapType())) . 'VariableModel';
        $this->variableModel = new $varModel;
    }

    public function getRenderedTemplate()
    {
        $this->convertDateObjectsToString();
        //echo "<pre>";print_r($this->page_data);exit;
        $this->environment->display($this->template, $this->page_data);
    }

}