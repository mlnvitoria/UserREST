using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Filters;
using NETCoreProject.Data;
using System;
using System.Linq;
using System.Threading.Tasks;

namespace NETCoreProject.Attributes
{
    [AttributeUsage(validOn: AttributeTargets.Class | AttributeTargets.Method)]
    public class ApiTokenAttribute : Attribute, IAsyncActionFilter
    {
        private const string ApiKeyName = "X-API-TOKEN";

        public async Task OnActionExecutionAsync(
        ActionExecutingContext context,
        ActionExecutionDelegate next)
        {
            if (context.ActionDescriptor.EndpointMetadata.Where(a => a.GetType().Name.Contains("AllowAnonymousAttribute") == true).Any())
            {
                await next();

                return;
            }
            if (!context.HttpContext.Request.Headers.TryGetValue(ApiKeyName, out var extractedApiKey))
            {
                context.Result = new ContentResult()
                {
                    StatusCode = 401,
                    Content = "Unauthorized"
                };
                return;
            }

            var dbContext = context.HttpContext
                .RequestServices
                .GetService(typeof(ProjectDbContext)) as ProjectDbContext;
            var repository = new UserRepository(dbContext);
            var user = await repository.FindByApiToken(extractedApiKey);

            if (user == null)
            {
                context.Result = new ContentResult()
                {
                    StatusCode = 401,
                    Content = "Unauthorized"
                };
                return;
            }

            await next();
        }
    }
}
