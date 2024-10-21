<?php
/* Objective
After we have finished our model implementation, a visualization of the shopping cart is needed. This is you next task. Build the shopping cart view for our shop system.
Lost your progress or you want to start from scratch? You can find the initial state of the source file here: Initial State

Scenario 1: Let's display something
To show the customer what he is going to order, we need a View-Template. View-Templates in Symfony are written with the twig template engine.
Our template.twig file is mostly written in HTML. Here is an example for using the template language twig. Also there are template variables given into this template. How to use Template Variables in Twig you can read here.

Here is an overview of the page structure you should implement:

HEADER
    H2
CONTENT
    MESSAGE
    H3
    TABLE

First of all, you need to import the CSS file from the following path (Hint: all required packages are installed):
/css/style.css
Our Template is divided in two sections. A header and a content section.
In the header section we want to place the title City Tower Leipzig as h2.
To display some messages to the customer, we need a message container with the CSS class message. It should have a second CSS class which is provided by the status template variable. The message content is provided by the template variable message. If there is no message, the message container should not be displayed.
The part of the array that provides these information looks like this:
...
"message" => "Ticket #1 added.",
"status" => "success",
...
In the content section we need a subtitle (as h3) Your Order combined with the parameterized order_id. This should look like:
Your Order #13
The order_id and the hashtag have the CSS class order_id and are italic.
To display the ordered tickets, we need a table with the CSS class tickets. The table head contains the following attributes: Ticket ID, Price Category, Price, Date, Remove. You should not change the order of the elements.
Generate the table content from the tickets variable which looks like this:
array(
    array(
        "id" => 1,
        "category" => "adult",
        "price" => "12.00",
        "date" => "22.10.2019",
        "url" => "/order/13/ticket/remove?id=1"
    )
)
The tickets variable is given into the template as variable tickets. So don't forget to iterate over all tickets. Also the tickets variable is not necessary so you should check if the variable exists to avoid errors. The Remove URL is displayed as a link with a simple - as label.
This should work with all other parameters passed to the view.
If you want, you now can be creative and make the order overview much prettier than we would expect it. Try to impress us!
*/

<head>
{# templates/user/notifications.html.twig #}
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />
</head>
<body>
    <div class="header">
        <h2> City Tower Leipzig </h2>
    </div>
    <div class="content">
        {%if message is defined and message is not empty and message is not null %}
            <div class="message {{ status }}">{{ message }}</div>
        {%endif %}
        <h3><i class="order_id">Your Order #{{ order_id }}</i></h3>
        <table class="tickets">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Price Category</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                {% if tickets is defined and tickets is not empty and tickets is not null %}
                    {% for ticket in tickets %}
                        <tr>
                            <td> {{ ticket.id }} </td>
                            <td> {{ ticket.category }} </td>
                            <td> {{ ticket.price }} </td>
                            <td> {{ ticket.date }} </td>
                            <td> <a href="{{ ticket.url }}"> - </a> </td>
                        </tr>
                    {% endfor %}
                {% endif %}
            </tbody>
        </table>
    </div>
</body>