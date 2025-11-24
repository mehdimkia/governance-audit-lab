<?php

declare(strict_types=1);

namespace OCA\GovernanceAuditLab\Controller;

use OCA\GovernanceAuditLab\AppInfo\Application;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Attribute\FrontpageRoute;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\Attribute\OpenAPI;
use OCP\AppFramework\Http\TemplateResponse;

use OCA\GovernanceAuditLab\Db\Label;
use OCA\GovernanceAuditLab\Db\LabelMapper;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;




/**
 * @psalm-suppress UnusedClass
 */
class PageController extends Controller {

	private LabelMapper $labelMapper;

	public function __construct(
		string $appName,
		IRequest $request,
		LabelMapper $labelMapper,
	) {
		parent::__construct($appName, $request);
		$this->labelMapper = $labelMapper;
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/')]
	public function index(): TemplateResponse {
		return new TemplateResponse(
			Application::APP_ID,
			'index',
		);
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/labels/debug')]
	public function debugLabels(): JSONResponse {
		$labels = $this->labelMapper->findAll();

		$data = array_map(static function (Label $label) {
			return [
				'id'          => $label->getId(),
				'name'        => $label->getName(),
				'description' => $label->getDescription(),
			];
		}, $labels);

		return new JSONResponse($data);
	}
}
