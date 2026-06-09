<?php declare(strict_types=1);

use SanderMuller\BoostCore\Config\BoostConfig;
use SanderMuller\BoostCore\Enums\Agent;
use SanderMuller\BoostCore\Enums\Tag;
use SanderMuller\BoostCore\Skills\Remote\RemoteSkillSource;

return BoostConfig::configure()
    ->withAgents([
        Agent::CLAUDE_CODE,
        Agent::COPILOT,
        Agent::CURSOR,
        Agent::JUNIE,
        Agent::KIRO,
    ])
    ->withAllowedVendors([
        'sandermuller/boost-skills',
        'sandermuller/package-boost-php',
    ])
    ->withTags(
        Tag::Php,
        Tag::Github,
        'release-automation',
    )
    ->withRemoteSkills([
        RemoteSkillSource::githubPath('peterfox/agent-skills', 'main', [
            'phpstan-developer' => 'phpstan-developer',
        ]),
    ]);
