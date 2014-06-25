<?php

namespace Stc\Bundle\BandBundle\ImportExport\Strategy\Import;

use Symfony\Component\Security\Core\SecurityContextInterface;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;

use Oro\Bundle\UserBundle\Entity\User;
use OroCRM\Bundle\ContactBundle\Entity\Contact;

use Stc\Bundle\BandBundle\Entity\Band;
use Stc\Bundle\BandBundle\Entity\BandStatus;

class BandImportStrategyHelper
{
    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * @param SecurityContextInterface $securityContext
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(SecurityContextInterface $securityContext, ManagerRegistry $managerRegistry)
    {
        $this->securityContext = $securityContext;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param string $entityName
     * @return EntityRepository
     */
    protected function getEntityRepository($entityName)
    {
        return $this->managerRegistry->getRepository($entityName);
    }

    /**
     * @param User $user
     * @return User|null
     */
    public function getUserOrNull(User $user)
    {
        $existingUser = null;
        $username = $user->getUsername();

        if ($username) {
            $existingUser = $this->getEntityRepository('OroUserBundle:User')->findOneBy(
                array('username' => $username)
            );
        }

        return $existingUser ?: null;
    }

    /**
     * @param Band $band
     * @return null|Band
     */
    public function getBandOrNull(Band $band)
    {
        $existingBand = null;
        $bandId = $band->getId();
        if ($bandId) {
            $existingBand = $this->getEntityRepository('StcBandBundle:Band')->find($bandId);
        }

        return $existingBand ?: null;
    }

    /**
     * @param Contact $contact
     * @return Contact|null
     */
    public function getContactOrNull(Contact $contact)
    {
        $existingContact = null;
        $contactId = $contact->getId();
        if ($contactId) {
            $existingContact = $this->getEntityRepository('OroCRMContactBundle:Contact')->find($contactId);
        }

        return $existingContact ?: null;
    }

    /**
     * @return User|null
     */
    public function getSecurityContextUserOrNull()
    {
        $token = $this->securityContext->getToken();
        if (!$token) {
            return null;
        }

        $user = $token->getUser();
        if (!$user) {
            return null;
        }

        return $this->getEntityRepository('OroUserBundle:User')->find($user->getId());
    }
}
