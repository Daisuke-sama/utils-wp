<?php

/* Procedure in OOP by Pavel Burylichau. */

namespace ; 


abstract class AbstractRestRouter {
	public const DEFAULT_NAMESPACE = 'my';

	protected $namespace = self::DEFAULT_NAMESPACE;
	protected $route = '';
	protected $callback;
	protected $permissions_callback;
	protected $methods = '';
	protected $is_override = false;
	protected $args = [];

	/**
	 * In the constructor of derived class set everything needed like in the comment.
	 */
	public function __construct() {
	    /*
	       $this->set_methods([])
            ->set_namespace('')
            ->set_args([])
            ->set_callback([])
            ->set_is_override(false)
            ->set_permissions_callback([])
            ->set_route('');
	    */
	}

	public function register_route(): void {
		register_rest_route(
			$this->namespace,
			$this->route,
			[
				'methods'             => $this->methods,
				'args'                => $this->args,
				'callback'            => $this->callback,
				'permission_callback' => $this->permissions_callback,
			],
			$this->is_override
		);
	}

	/**
	 * @param string $namespace By default it is the constant self::DEFAULT_NAMESPACE.
	 *
	 * @return self
	 */
	public function set_namespace( string $namespace ): self {
		$this->namespace = $namespace;

		return $this;
	}

	/**
	 * @param string $route
	 *
	 * @return self
	 */
	public function set_route( string $route ): self {
		$this->route = $route;

		return $this;
	}

	/**
	 * @param mixed $callback
	 *
	 * @return self
	 */
	public function set_callback( callable $callback ): self {
		$this->callback = $callback;

		return $this;
	}

	/**
	 * @param mixed $permissions_callback
	 *
	 * @return self
	 */
	public function set_permissions_callback( callable $permissions_callback ): self {
		$this->permissions_callback = $permissions_callback;

		return $this;
	}

	/**
	 * @param string $methods
	 *
	 * @return self
	 */
	public function set_methods( string $methods ): self {
		$this->methods = $methods;

		return $this;
	}

	/**
	 * @param bool $is_override
	 *
	 * @return self
	 */
	public function set_is_override( bool $is_override ): self {
		$this->is_override = $is_override;

		return $this;
	}

	/**
	 * @param array $args An array of arguments for the registering REST routes, in specific WP format.
	 * The correctness of the setup is on the User's sanity. Look at the add_arg() function for details.
	 *
	 * @return self
	 */
	public function set_args( array $args ): self {
		$this->args = $args;

		return $this;
	}

	/**
	 * Adds an argument for the callback of the route.
	 * The function can be called as many times as arguments are required for the callback of the route.
	 *
	 * @param string $name
	 * @param mixed $default
	 * @param bool $required
	 * @param callable|null $validate_cb
	 * @param callable|null $sanitize_cb
	 *
	 * @return $this
	 */
	public function add_arg( string $name, $default, bool $required = false, ?callable $validate_cb = null, ?callable $sanitize_cb = null ): self {
		$this->args[] = [
			$name => [
				'default'           => $default,
				'required'          => $required,
				'validate_callback' => $validate_cb,
				'sanitize_callback' => $sanitize_cb,
			]
		];

		return $this;
	}
}

