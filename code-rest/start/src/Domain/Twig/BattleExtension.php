<?php

namespace KnpU\Domain\Twig;

use KnpU\Domain\Model\Programmer;
use KnpU\Domain\Repository\ProgrammerRepository;
use KnpU\Domain\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class BattleExtension extends \Twig_Extension
{
    private $requestStack;

    private $programmerRepository;

    private $projectRepository;

    public function __construct(
        RequestStack $requestStack,
        ProgrammerRepository $programmerRepository,
        ProjectRepository $projectRepository
    ) {
        $this->requestStack = $requestStack;
        $this->programmerRepository = $programmerRepository;
        $this->projectRepository = $projectRepository;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('asset', [$this, 'getAssetPath']),
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('powerLevelClass', [$this, 'getPowerLevelClass']),
            new \Twig_SimpleFilter('avatar_path', [$this, 'getAvatarPath']),
        ];
    }

    public function getAssetPath($path)
    {
        return $this->requestStack->getCurrentRequest()->getBasePath().'/'.$path;
    }

    public function getAvatarPath($number)
    {
        return \sprintf('img/avatar%s.png', $number);
    }

    public function getPowerLevelClass(Programmer $programmer)
    {
        $powerLevel = $programmer->powerLevel;

        switch (true) {
            case $powerLevel <= 3:
                return 'danger';
                break;
            case $powerLevel <= 7:
                return 'warning';
                break;
            default:
                return 'success';
        }
    }

    public function getName()
    {
        return 'code_battle';
    }
}
