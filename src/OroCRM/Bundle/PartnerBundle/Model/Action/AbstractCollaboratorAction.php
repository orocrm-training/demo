<?php

namespace OroCRM\Bundle\PartnerBundle\Model\Action;

use Oro\Bundle\WorkflowBundle\Model\Action\AbstractAction;
use Oro\Bundle\WorkflowBundle\Model\ContextAccessor;
use OroCRM\Bundle\PartnerBundle\Exception\InvalidParameterException;
use OroCRM\Bundle\PartnerBundle\Model\GitHubCollaboratorManager;

abstract class AbstractCollaboratorAction extends AbstractAction
{
    const OPTION_KEY_USERNAME = 'username';

    /**
     * @var GitHubCollaboratorManager
     */
    protected $gitHubCollaboratorManager;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param ContextAccessor $contextAccessor
     * @param GitHubCollaboratorManager $gitHubCollaboratorManager
     */
    public function __construct(ContextAccessor $contextAccessor, GitHubCollaboratorManager $gitHubCollaboratorManager)
    {
        $this->gitHubCollaboratorManager = $gitHubCollaboratorManager;
        parent::__construct($contextAccessor);
    }

    /**
     * @param $context
     * @return string
     * @throws InvalidParameterException
     */
    protected function getGitHubUsername($context)
    {
        $username = $this->contextAccessor->getValue($context, $this->options[self::OPTION_KEY_USERNAME]);
        if (!$username) {
            throw new InvalidParameterException('Git hub username not found');
        }

        return $username;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array $options)
    {
        if (empty($options[self::OPTION_KEY_USERNAME])) {
            throw new InvalidParameterException('GitHub username is required');
        }

        $this->options = $options;
    }
}
