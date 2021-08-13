using Microsoft.AspNetCore.Mvc;
using NETCoreProject.Models;
using System.Collections.Generic;
using System.Threading.Tasks;

namespace NETCoreProject.Data.Interfaces
{
    public interface ICustomerRepository : IRepository<Customer>
    {
        public Task<List<Customer>> Get(
            [FromQuery] int limit = 10,
            [FromQuery] int page = 1,
            [FromQuery] bool? enabled = null);
    }
}
