<?php 

namespace TM\Enum;

enum TaskStatus: string {
    case TODO = "TODO";
    case DOING = "DOING";
    case DONE = "DONE";
}