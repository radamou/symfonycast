<?php

namespace KnpU\Domain\Battle;

use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use KnpU\Domain\Programmer\Programmer;
use KnpU\Domain\Project\Project;

/**
 * @Serializer\ExclusionPolicy("all")
 * @Hateoas\Relation(
 *     "programmer",
 *     href=@Hateoas\Route(
 *         "api_programmers_show",
 *         parameters={ "nickname": "expr(object.programmer.nickname)" }
 *     ),
 *     embedded="expr(object.programmer)"
 * )
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *         "api_battle_show",
 *         parameters={ "nickname": "expr(object.id)" }
 *     )
 * )
 */
class Battle
{
    /**
     * @Serializer\Expose
     */
    public $id;

    /** @var Programmer */
    public $programmer;

    /** @var Project */
    public $project;

    /**
     * @Serializer\Expose
     */
    public $didProgrammerWin;

    /**
     * @Serializer\Expose
     */
    public $foughtAt;

    /**
     * @Serializer\Expose
     */
    public $notes;
}
