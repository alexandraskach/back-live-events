Feature: Manage blog posts
  Scenario: Create a blog post
    When I add "Content-Type" header equal to "application/ld+json"
    """
    {
      "title": "Hello a title",
      "content": "The content is suppose to be at least 20 characters",
      "slug": "a-new-slug"
    }
    """
    Then the response status code should be 201
   