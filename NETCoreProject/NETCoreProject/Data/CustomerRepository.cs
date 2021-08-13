using Microsoft.EntityFrameworkCore;
using NETCoreProject.Data.Interfaces;
using NETCoreProject.Models;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace NETCoreProject.Data
{
    public class CustomerRepository : EfCoreRepository<Customer>, ICustomerRepository
    {
        public CustomerRepository(ProjectDbContext context) : base(context) { }

        public async Task<List<Customer>> Get(int limit = 10,
            int page = 1,
            bool? enabled = null)
        {
            var startRow = (page - 1) * limit;

            if (enabled != null)
            {
                return await DbSet.Where(c => c.Enabled == (bool)enabled)
                    .Skip(startRow)
                    .Take(limit)
                    .ToListAsync();
            }

            return await DbSet.Skip(startRow)
                .Take(limit)
                .ToListAsync();
        }
    }
}
