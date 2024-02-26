<?php

namespace App\Pipes;

use Closure;

class CheckEmailExistsPipe
{
    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function handle($builder, Closure $next)
    {
        if (!empty($this->email)) {
            $builder->where('email', $this->email);
        }

        return $next($builder);
    }
}
