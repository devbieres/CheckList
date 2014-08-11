<?php

namespace DevBieres\CommonUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DevBieresCommonUserBundle extends Bundle
{
	public function getParent() { return  'FOSUserBundle'; }
}
