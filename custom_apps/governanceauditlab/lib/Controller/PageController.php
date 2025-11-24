<?php

declare(strict_types=1);

namespace OCA\GovernanceAuditLab\Controller;

use OCA\GovernanceAuditLab\AppInfo\Application;
use OCA\GovernanceAuditLab\Db\Label;
use OCA\GovernanceAuditLab\Service\LabelService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Attribute\AdminRequired;
use OCP\AppFramework\Http\Attribute\FrontpageRoute;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\Attribute\OpenAPI;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

/**
 * @psalm-suppress UnusedClass
 */
class PageController extends Controller {

	private LabelService $labelService;

	public function __construct(
		string $appName,
		IRequest $request,
		LabelService $labelService,
	) {
		parent::__construct($appName, $request);
		$this->labelService = $labelService;
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
		$labels = $this->labelService->getAll();

		$data = array_map(static function (Label $label) {
			return [
				'id'          => $label->getId(),
				'name'        => $label->getName(),
				'description' => $label->getDescription(),
			];
		}, $labels);

		return new JSONResponse($data);
	}

	#[NoCSRFRequired]
	#[AdminRequired] // only admins may create labels
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'POST', url: '/labels')]
	public function createLabel(string $name, ?string $description = null): JSONResponse {
		try {
			$label = $this->labelService->create($name, $description);
	
			return new JSONResponse([
				'id'          => $label->getId(),
				'name'        => $label->getName(),
				'description' => $label->getDescription(),
			], 201);
		} catch (\InvalidArgumentException $e) {
			return new JSONResponse([
				'error' => $e->getMessage(),
			], 400);
		} catch (\Throwable $e) {
			return new JSONResponse([
				'error'     => $e->getMessage(),
				'exception' => get_class($e),
			], 500);
		}
	}
}
