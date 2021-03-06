<?php

namespace App\Rules;

use App\RegisterInvitation;
use Illuminate\Contracts\Validation\Rule;

class NewUserRoleID implements Rule
{

    private $email;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $data = RegisterInvitation::where('email',$this->email)
            ->where('invite_as_role_id',$value)->where('user_registered',0)->first();

        if($data!=null) return true;
        else return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Role compromised. Please retry.';
    }
}
