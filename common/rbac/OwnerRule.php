<?php

namespace common\rbac;

use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
class OwnerRule extends Rule
{
    public $name = 'isOwner';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        var_dump($user);
        var_dump($item);
        var_dump($params);
        if (isset($params['seller']))
            return $params['seller']->userId == $user;
        elseif (isset($params['user']))
            return $params['user'] == $user;

        return false;
    }
}