<?php

namespace Core\Enums;

enum HttpMethod
{
    case GET = "GET";
    case POST = "POST";
    case DELETE = "DELETE";
    case PUT = "PUT";
    case PATCH = "PATCH";
    case HEAD = "HEAD";
}