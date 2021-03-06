<?php

namespace App\Tests\Controller;

use App\Tests\AppTestCase;

final class PublicControllerTest extends AppTestCase
{
    public function testIndex(): void
    {
        $this->kernelBrowser->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'This is Nestor');
    }
}
