<?php

namespace ZeroToProd\ServiceModel;

interface CastsAttribute
{
    public function get($value);

    public function set($value);
}