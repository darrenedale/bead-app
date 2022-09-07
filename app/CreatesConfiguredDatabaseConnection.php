<?php

namespace App;

use Equit\Database\Connection;

/**
 * Trait for Application class(es) to consistently instantiate the configured database connection.
 */
trait CreatesConfiguredDatabaseConnection
{
	/**
	 * Constrain the trait to classes that provide access to config (i.e. Application subclasses).
	 *
	 * @param string $key THe configuration key sought.
	 * @param mixed $default The default value to return if the key does not exist.
	 *
	 * @return mixed The value, or `null` if it is not present and no default was provided.
	 */
	public abstract function config(string $key, $default = null);

	/**
	 * Create a database connection if one is configured in `config/db.php`.
	 * @return Connection|null
	 */
	protected function configuredDatabaseConnection(): ?Connection
	{
		if (!empty($this->config("db.name"))) {
			$resource = "{$this->config("db.type")}:host={$this->config("db.host")};dbname={$this->config("db.name")}";

			if (!empty($this->config("db.port"))) {
				$resource .= ";port={$this->config("db.port")}";
			}

			if (!empty($this->config("db.charset"))) {
				$resource .= ";charset={$this->config("db.charset")}";
			}

			return new Connection($resource, $this->config("db.user"), $this->config("db.password"));
		}

		return null;
	}
}
