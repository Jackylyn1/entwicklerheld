<?php
/* Objective - Stage 1
In this stage we add some useful search functionality to our User model. The User and all other models look like this: ER-Diagram.
Lost your progress or you want to start from scratch? You can find the initial state of the source file here: Initial State

Scenario 1: Get a user
The first thing we will do is to get a user by their username.

The function getUserByName($username) should return the User with the corresponding username.
The function call
getUserByName('plumplori')
should return the User object of Plumplori. Printed it looks like this:
Plumplori. Email: hallo@entwicklerheld.de, Address: South Ost Asia
For this you can use the Doctrine ORM. Click here for a little example how to use Repositories in Symfony.

Protect your function from wrong parameter data types.
This should work for other user names as well.
Scenario 2: Lost tickets
"Hey, I found some tickets but they're not mine. Whose are they?"
To check who misses their tickets we want to implement a function in our User model. Hint: You have to make a more complex query. Click here to learn more about the ORM Doctrine.

Implement the getUserByTicket($id)function.
The function should return the correct owner of the ticket:
getUserByTicket(`id`);
should return:
Plumplori. Email: hallo@entwicklerheld.de, Address: South Ost Asia
Make sure your function allows only the parameter data type Integer.
Also make sure you return only null or a User object.
Your implementation should work for other function calls as well.
*/

namespace App\Repository;

use App\Entity\User;
use App\Entity\Ticket;
use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use SebastianBergmann\CodeCoverage\RuntimeException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User
     */
    public function getUserByName(String $name): ?User
    {
        $userByName = $this->getEntityManager()->getRepository(User::class)
        ->findOneBy(['name' => $name]);
        return $userByName;
    }

    /**
     * @return User
     */
    public function getUserByTicket(int $id): ?User
    {
        $order = $this->getEntityManager()->getRepository(Orders::class)
        ->createQueryBuilder('orders')
        ->select('orders', 'resultUser')
        ->join('orders.tickets', 'ticket')
        ->join('orders.user', 'resultUser')
        ->where('ticket.id = :id')
        ->setParameter('id', $id)
        ->getQuery()->getOneOrNullResult();
        return $order->getUser();
    }
}