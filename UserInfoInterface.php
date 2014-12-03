<?php

namespace nkovacs\errbit;

interface UserInfoInterface
{
    /**
     * Return an array with user info to pass to errbit.
     * Return null to omit user info.
     * @return array|null
     */
    public function getErrbitUserInfo();
}
