using NETCoreProject.Models;
using NETCoreProject.Helpers;
using System;
using System.Collections.Generic;
using System.Threading.Tasks;
using System.Linq;
using Microsoft.EntityFrameworkCore;
using NETCoreProject.Data.Interfaces;

namespace NETCoreProject.Data
{
    public class UserRepository : EfCoreRepository<User>, IUserRepository
    {
        public UserRepository(ProjectDbContext context) : base(context) { }

        public async Task<User> FindByApiToken(string apiToken)
        {
            return await DbSet.FirstOrDefaultAsync(u => u.ApiToken == apiToken);
        }

        public new async Task<User> Create(User user)
        {
            var helper = new ApiTokenHelper();
            user.ApiToken = helper.GenerateToken();

            return await base.Create(user);
        }

        public async Task<User> Update(User user)
        {
            var oldUser = Context.User.AsNoTracking<User>().FirstOrDefault(u => u.Id == user.Id);
            if (oldUser.Id == 0)
            {
                return null;
            }

            user.ApiToken = oldUser.ApiToken;
            user.CreatedAt = oldUser.CreatedAt;
            user.DeletedAt = null;

            return await base.Update(user);
        }
    }
}
