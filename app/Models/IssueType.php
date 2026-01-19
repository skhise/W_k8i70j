<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class IssueType extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'master_issue_type';
   protected $fillable = [
       'issue_name',
    ];
}