<?php
declare(strict_types=1);
/**
 * @copyright Copyright (c) 2020, Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @author Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OC\EventDispatcher;

use OCP\ILogger;
use Symfony\Component\EventDispatcher\GenericEvent;

class GenericEventWrapper extends GenericEvent {

	/** @var ILogger */
	private $logger;

	/** @var GenericEvent */
	private $event;

	/** @var string */
	private $eventName;

	public function __construct(ILogger $logger, string $eventName, ?GenericEvent $event) {
		$this->logger = $logger;
		$this->event = $event;
		$this->eventName = $eventName;
	}

	public function __call($name, $arguments) {
		$this->logger->info(
			'Deprecated event type for {name}: {class} is used',
			[ 'name' => $this->eventName, 'class' => is_object($this->event) ? get_class($this->event) : 'null' ]
		);
		return call_user_func_array([$this->event, $name], $arguments);
	}
}
