<?php

namespace App;

use Equit\DatabaseConnection;

trait CreatesConfiguredDatabaseConnection
{
	public abstract function config(string $key, $default = null);

	protected function configuredDatabaseConnection(): ?DatabaseConnection
	{
		if (!empty($this->config("db.db"))) {
			$resource = "{$this->config("db.type")}:host={$this->config("db.host")};dbname={$this->config("db.name")}";

			if (!empty($this->config("db.port"))) {
				$resource .= ";port={$this->config("db.port")}";
			}

			if (!empty($this->config("db.charset"))) {
				$resource .= ";charset={$this->config("db.charset")}";
			}

			return new DatabaseConnection($resource, $this->config("db.user"), $this->config("db.password"));
		}

		return null;
	}
}
