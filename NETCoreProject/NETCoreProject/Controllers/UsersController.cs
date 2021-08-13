using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using NETCoreProject.Data.Interfaces;
using NETCoreProject.Models;
using System.Threading.Tasks;

namespace NETCoreProject.Controllers
{
    [ApiController]
    [Route("api/v1/users")]
    [Produces("application/json")]
    public class UsersController : ProjectController<User, IUserRepository>
    {
        public UsersController(IUserRepository repository) : base(repository) { }

        [AllowAnonymous]
        public override async Task<ActionResult<User>> Post(User entity)
        {
            var user = await base.Post(entity);

            return user;
        }
    }
}
