<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
    public function contacts()
    {
        return $this->hasMany(ContactPerson::class);
    }
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function InvoiceItem()
    {

    }
    public function contactpersons()
    {
        return $this->hasMany(ContactPerson::class);
    }
    public function projectdocument()
    {
        return $this->hasMany(ProjectDocument::class);
    }

}