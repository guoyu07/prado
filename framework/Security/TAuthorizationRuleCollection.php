<?php
/**
 * TAuthorizationRule, TAuthorizationRuleCollection class file
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link https://github.com/pradosoft/prado
 * @copyright Copyright &copy; 2005-2016 The PRADO Group
 * @license https://github.com/pradosoft/prado/blob/master/LICENSE
 * @package Prado\Security
 */

namespace Prado\Security;
use Prado\Exceptions\TInvalidDataTypeException;

/**
 * TAuthorizationRuleCollection class.
 * TAuthorizationRuleCollection represents a collection of authorization rules {@link TAuthorizationRule}.
 * To check if a user is allowed, call {@link isUserAllowed}.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package Prado\Security
 * @since 3.0
 */
class TAuthorizationRuleCollection extends \Prado\Collections\TList
{
	/**
	 * @param IUser the user to be authorized
	 * @param string verb, can be empty, 'post' or 'get'.
	 * @param string the request IP address
	 * @return boolean whether the user is allowed
	 */
	public function isUserAllowed($user,$verb,$ip)
	{
		if($user instanceof IUser)
		{
			$verb=strtolower(trim($verb));
			foreach($this as $rule)
			{
				if(($decision=$rule->isUserAllowed($user,$verb,$ip))!==0)
					return ($decision>0);
			}
			return true;
		}
		else
			return false;
	}

	/**
	 * Inserts an item at the specified position.
	 * This overrides the parent implementation by performing additional
	 * operations for each newly added TAuthorizationRule object.
	 * @param integer the specified position.
	 * @param mixed new item
	 * @throws TInvalidDataTypeException if the item to be inserted is not a TAuthorizationRule object.
	 */
	public function insertAt($index,$item)
	{
		if($item instanceof TAuthorizationRule)
			parent::insertAt($index,$item);
		else
			throw new TInvalidDataTypeException('authorizationrulecollection_authorizationrule_required');
	}
}