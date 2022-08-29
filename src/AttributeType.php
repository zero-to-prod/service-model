<?php

namespace ZeroToProd\ServiceModel;

enum AttributeType
{
    case null;
    case int;
    case string;
    case datetime_immutable;
}