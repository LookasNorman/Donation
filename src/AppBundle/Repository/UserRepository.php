<?php

namespace AppBundle\Repository;

/**
 * UserRepository
 *
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function showAllAdmin()
    {
        $query = $this->getEntityManager()
            ->createQuery('SELECT u FROM AppBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_ADMIN"%' );

        return $users = $query->getResult();
    }
}
