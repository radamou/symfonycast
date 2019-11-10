<?php

namespace KnpU\Domain\Home;

use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *         "api_homepage"
 *     ),
 *     attributes={"title": "Your API starting point" }
 * )
 * @Hateoas\Relation(
 *     "programmers",
 *     href=@Hateoas\Route(
 *         "api_programmers_list"
 *     ),
 *     attributes={"title": "The list of all programmers" }
 * )
 */
class Homepage
{
    private $message = 'Welcome to the CodeBattles API! Look around at the _links to browse the API. And have a crazy-cool day.';
}
