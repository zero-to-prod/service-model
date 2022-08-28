<?php

namespace ZeroToProd\ServiceModel;

enum DataType
{
    case null;
    case int;
    case string;
    case datetime_immutable;
}