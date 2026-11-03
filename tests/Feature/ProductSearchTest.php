<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    public function test_a_search_requires_text_or_an_image(): void
    {
        $response = $this->from('/product')->post(route('product.search'));

        $response->assertRedirect('/product')
            ->assertSessionHasErrors('search');
    }
}
