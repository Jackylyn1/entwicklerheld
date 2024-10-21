<?php

/*
Objective
The last task you have to do is the final routing. For this task we use a controller (Symfony Controller). Add all the routes and functionality to the controller to get the shop system working. The ER-Diagram of the database should help you a bit: ER-Diagram
Lost your progress or you want to start from scratch? You can find the initial state of the source file here: Initial State


Scenario 1: New Order
The first action of the TicketController you should implement is the new order function.

The function should called when a request is send to the url "/order/add/":
Your function should handle a POST request and create an Order associated with the user with the given username in the POST data e.g:
{username: "Ronny"}
should result in an order (pseudo code):
{user_id: `Ronny_Id`, tickets: empty, price: 0, date: now, shipping: false}
You should return a rendered template (Symfony example). The template URL is: overview_s.html.twig. Pass the parameters like in the example array:
array(
    "order_id" => 13,
    "message" => "Ticket #1 added.",
    "status" => "success|fail",
    "tickets" => array(
        array(
            "id" => 1,
            "category" => "adult",
            "price" => "12.00",
            "date" => "22.10.2019",
            "url" => "/order/13/ticket/remove?id=1"
        )
    )
)
The message to the user is the following success message: New Order created. The tickets value should provide all tickets, that are belonging to the order at this time.
Be aware of the right price display and URL rendering. Also pay attention to the pricing category and the order id.
If the username doesn't exist, return a 404 HTTP status code.
This should work for other usernames as well.


Scenario 2: Add tickets to the order
We need to add tickets to the order. Pay attention to the ticket creation.

The next route is:
Add a ticket:
/order/{order_id}/ticket/add/
Your next function should add a ticket with the given order id when it receives a POST request with the following data:
{category: "adult", date: "30.09.2051"}
You have to find the TicketCategory by the given POST data category to set the category of your created ticket. Also you need the date to set ticket date.
Return the rendered twig template as above with the messages #`ticket_id` was added to your order. and a success state for add ticket.
If the order id or the category doesn't exist, return a 404 status code.
Your implementation should work for other orders and tickets as well.
*/
namespace App\Controller;

use App\Entity\TicketCategory;
use App\Entity\Ticket;
use App\Entity\User;
use App\Entity\Orders;
use App\Repository\TicketCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class TicketController extends AbstractController
{

    /**
    * @Route("/order/{order_id}/ticket/add/", methods={"POST"})
    */
    public function addTicket(Request $request, EntityManagerInterface $entityManager, $order_id):Response {
        $category = $request->request->get('category');
        $date = $request->request->get('date');
        if(empty($category) || empty($date)) return (new Response)->setStatusCode(404);
        $ticketCategory = $entityManager->getRepository(TicketCategory::class)->findOneBy(['name' => $category]);
        $ticket = new Ticket();
        $ticket->setCategory($ticketCategory);
        $ticket->setValidDate(\DateTime::createFromFormat('d.m.Y',$date));
        $order = $entityManager->getRepository(Orders::class)->find($order_id);
        if(empty($order)) return (new Response)->setStatusCode(404);
        $ticket->setOrderId($order);
        $entityManager->persist($ticket);
        $order->addTicket($ticket);
        $entityManager->persist($order);
        $entityManager->flush();
        return $this->render('overview_s.html.twig', [
            'order_id' => $order_id,
            'message' => ' #' . $ticket->getId() . ' was added to your order. ',
            'status' => 'success',
            'tickets' => $this->ticketsToArray($order->getTickets())
        ]);

    }

    public function ticketsToArray($tickets){
        $ticketsAsArray = $tickets->toArray();
        $ticketsAsArrayFormatted = [];
        foreach($ticketsAsArray as $key => $ticket){
            $order = $ticket->getOrderId();
            $ticketsAsArrayFormatted[$key] = [
                'id' => $ticket->getId(),
                'category' => $ticket->getCategory()->getName(),
                'price' => $order->getPrice(),
                'date' => $ticket->getValidDate()->format('d.m.Y'),
                'url' => '/order/' . $order->getId() . '/ticket/remove?id=' . $ticket->getId()
            ];
        }
        return $ticketsAsArrayFormatted;
    }


    /**
    * @Route("/order/add/", methods={"POST"})
    */
    public function add(Request $request, EntityManagerInterface $entityManager):Response {
        $username = $request->request->get('username');
        $order = new Orders();
        $user = $entityManager->getRepository(User::class)->findOneBy(['name' => $username]);
        if(null === $user) return (new Response)->setStatusCode(404);
        $order->setUser($user);
        $order->setPrice(0);
        $order->setDate(new \DateTime());
        $order->setShipping(false);
        $entityManager->persist($order);
        $entityManager->flush();

        return $this->render('overview_s.html.twig', [
            'order_id' => $order->getId(),
            'message' => ' New Order created ',
            'status' => 'success',
            'tickets' => $this->ticketsToArray($order->getTickets())
        ]);
    }
}