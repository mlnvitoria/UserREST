using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using NETCoreProject.Attributes;
using NETCoreProject.Data.Interfaces;
using NETCoreProject.Models;
using System.Collections.Generic;
using System.Threading.Tasks;

namespace NETCoreProject.Controllers
{
    [ApiToken]
    [ApiController]
    [Route("api/v1/customers")]
    public class CustomersController : ProjectController<Customer, ICustomerRepository>
    {
        public CustomersController(ICustomerRepository repository) : base(repository) { }

        [ProducesResponseType(StatusCodes.Status200OK)]
        [ProducesResponseType(StatusCodes.Status404NotFound)]
        [HttpGet]
        public async Task<ActionResult<IEnumerable<Customer>>> Get(
            [FromQuery] int limit = 10, 
            [FromQuery] int page = 1, 
            [FromQuery] bool? enabled = null)
        {
            var customers = await Repository.Get(limit, page, enabled);

            return customers;
        }
    }
}
