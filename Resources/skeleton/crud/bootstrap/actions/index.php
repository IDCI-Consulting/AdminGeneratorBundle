
    /**
     * Lists all {{ entity }} entities.
     *
{% if 'annotation' == format %}
     * @Route("/", name="{{ route_name_prefix }}")
     * @Template()
{% endif %}
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('{{ bundle }}:{{ entity }}')->findAll();

        $adapter = new ArrayAdapter($entities);
        $pager = new PagerFanta($adapter);
        $pager->setMaxPerPage($this->container->getParameter('max_per_page'));
        
        try {
            $pager->setCurrentPage($request->query->get('page', 1)); 
        } 
        catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException(); 
        }
        
{% if 'annotation' == format %}
        return array(
            'pager' => $pager,
        );
{% else %}
        return $this->render('{{ bundle }}:{{ entity|replace({'\\': '/'}) }}:index.html.twig', array(
            'pager' => $pager,
        ));
{% endif %}
    }