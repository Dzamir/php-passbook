<?php

namespace Passbook\Tests;

use Passbook\Pass;
use Passbook\PassFactory;
use Passbook\Pass\Field;
use Passbook\Pass\Barcode;
use Passbook\Pass\Beacon;
use Passbook\Pass\Location;
use Passbook\Pass\Structure;
use Passbook\Type\BoardingPass;
use Passbook\Type\Coupon;
use Passbook\Type\EventTicket;
use Passbook\Type\Generic;
use Passbook\Type\StoreCard;

class PassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PassInterface
     */
    protected $boardingPass;

    /**
     * @var PassInterface
     */
    protected $coupon;

    /**
     * @var PassInterface
     */
    protected $eventTicket;

    /**
     * @var PassInterface
     */
    protected $generic;

    /**
     * @var PassInterface
     */
    protected $storeCard;

    /**
     * Boarding Pass
     */
    public function testBoardingPass()
    {
        $boardingPass = new BoardingPass(uniqid(), 'Lorem ipsum', BoardingPass::TYPE_BUS);
        $json = PassFactory::serialize($boardingPass);
        $array = json_decode($json, true);

        $this->assertArrayHasKey('transitType', $array);
    }

    /**
     * Store Card
     */
    public function testStoreCard()
    {
        $json = PassFactory::serialize($this->storeCard);
        $array = json_decode($json, true);
    }

    /**
     * Event Ticket
     */
    public function testEventTicket()
    {
        $this->eventTicket->setBackgroundColor('rgb(60, 65, 76)');
        $this->assertSame('rgb(60, 65, 76)', $this->eventTicket->getBackgroundColor());
        $this->eventTicket->setLogoText('Apple Inc.');
        $this->assertSame('Apple Inc.', $this->eventTicket->getLogoText());

        // Add location
        $location = new Location(59.33792, 18.06873);
        $this->eventTicket->addLocation($location);

        // Create pass structure
        $structure = new Structure();

        // Add primary field
        $primary = new Field('event', 'The Beat Goes On');
        $primary->setLabel('Event');
        $structure->addPrimaryField($primary);

        // Add secondary field
        $secondary = new Field('location', 'Moscone West');
        $secondary->setLabel('Location');
        $structure->addSecondaryField($secondary);

        // Add auxiliary field
        $auxiliary = new Field('datetime', '2013-04-15 @10:25');
        $auxiliary->setLabel('Date & Time');
        $structure->addAuxiliaryField($auxiliary);

        // Relevant date
        $this->eventTicket->setRelevantDate(new \DateTime());

        // Set pass structure
        $this->eventTicket->setStructure($structure);

        // Add barcode
        $barcode = new Barcode('PKBarcodeFormatQR', 'barcodeMessage');
        $this->eventTicket->setBarcode($barcode);

        $json = PassFactory::serialize($this->eventTicket);
        $array = json_decode($json, true);

        $this->assertArrayHasKey('eventTicket', $array);
        $this->assertArrayHasKey('locations', $array);
        $this->assertArrayHasKey('barcode', $array);
        $this->assertArrayHasKey('logoText', $array);
        $this->assertArrayHasKey('backgroundColor', $array);
        $this->assertArrayHasKey('eventTicket', $array);
        $this->assertArrayHasKey('relevantDate', $array);
    }

    /**
     * Generic
     */
    public function testGeneric()
    {
        $this->generic->setBackgroundColor('rgb(60, 65, 76)');
        $this->assertSame('rgb(60, 65, 76)', $this->generic->getBackgroundColor());
        $this->generic->setLogoText('Apple Inc.');
        $this->assertSame('Apple Inc.', $this->generic->getLogoText());

        $this->generic
            ->setFormatVersion(1)
            ->setDescription('description')
        ;

        // Create pass structure
        $structure = new Structure();

        // Add primary field
        $primary = new Field('event', 'The Beat Goes On');
        $primary->setLabel('Event');
        $structure->addPrimaryField($primary);

        // Add back field
        $back = new Field('back', 'Hello World!');
        $back->setLabel('Location');
        $structure->addSecondaryField($back);

        // Add auxiliary field
        $auxiliary = new Field('datetime', '2014 Aug 1');
        $auxiliary->setLabel('Date & Time');
        $structure->addAuxiliaryField($auxiliary);

        // Set pass structure
        $this->generic->setStructure($structure);

        // Add beacon
        $beacon = new Beacon('abcdef01-2345-6789-abcd-ef0123456789');
        $this->generic->addBeacon($beacon);

        $json = PassFactory::serialize($this->generic);
        $array = json_decode($json, true);

        $this->assertArrayHasKey('beacons', $array);
        $this->assertArrayHasKey('generic', $array);
    }

    /**
     * Pass
     */
    public function testPass()
    {
        $this->pass
            ->setWebServiceURL('http://example.com')
            ->setForegroundColor('rgb(0, 255, 0)')
            ->setBackgroundColor('rgb(0, 255, 0)')
            ->setLabelColor('rgb(0, 255, 0)')
            ->setAuthenticationToken('123')
            ->setType('generic')
            ->setSuppressStripShine(false)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->coupon       = new Coupon(uniqid(), 'Lorem ipsum');
        $this->eventTicket  = new EventTicket(uniqid(), 'Lorem ipsum');
        $this->generic      = new Generic(uniqid(), 'Lorem ipsum');
        $this->storeCard    = new StoreCard(uniqid(), 'Lorem ipsum');
        $this->pass         = new Pass(uniqid(), 'Lorem ipsum');
    }
}
