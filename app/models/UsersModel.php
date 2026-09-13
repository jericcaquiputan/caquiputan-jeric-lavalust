<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primary_key = 'id';
    protected $timestamps = false;
    protected $fillable = ['firstname', 'lastname', 'email', 'username', 'password'];
    protected $guarded = ['id'];
    protected $has_soft_delete = false;
}
