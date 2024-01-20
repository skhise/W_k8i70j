<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueType extends Model
{
    use HasFactory;
    
    protected $table = 'master_issue_type';
   protected $fillable = [
       'issue_name',
    ];
}